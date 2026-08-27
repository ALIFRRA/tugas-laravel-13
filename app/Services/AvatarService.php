<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AvatarService
{
    public const BOCCI_CHARACTERS = [
        'hitori gotoh' => 'https://api.dicebear.com/9.x/avataaars/svg?seed=hitori-gotoh&backgroundColor=ffe7f3&hairColor=1e1e1e&clothesColor=ec4899&clothesType=blazerShirt',
        'ikuyo kita' => 'https://api.dicebear.com/9.x/avataaars/svg?seed=ikuyo-kita&backgroundColor=ffe7f3&hairColor=1e1e1e&clothesColor=f472b6&clothesType=blazerShirt',
        'nijika ijichi' => 'https://api.dicebear.com/9.x/avataaars/svg?seed=nijika-ijichi&backgroundColor=ffe7f3&hairColor=1e1e1e&clothesColor=db2777&clothesType=blazerShirt',
        'ryo yamada' => 'https://api.dicebear.com/9.x/avataaars/svg?seed=ryo-yamada&backgroundColor=ffe7f3&hairColor=1e1e1e&clothesColor=be185d&clothesType=blazerShirt',
        'futari gotoh' => 'https://api.dicebear.com/9.x/avataaars/svg?seed=futari-gotoh&backgroundColor=ffe7f3&hairColor=1e1e1e&clothesColor=ec4899&clothesType=blazerShirt',
        'yoyoko ohtsuki' => 'https://api.dicebear.com/9.x/avataaars/svg?seed=yoyoko-ohtsuki&backgroundColor=ffe7f3&hairColor=1e1e1e&clothesColor=f472b6&clothesType=blazerShirt',
        'eliza shimizu' => 'https://api.dicebear.com/9.x/avataaars/svg?seed=eliza-shimizu&backgroundColor=ffe7f3&hairColor=1e1e1e&clothesColor=db2777&clothesType=blazerShirt',
        'shima iwashita' => 'https://api.dicebear.com/9.x/avataaars/svg?seed=shima-iwashita&backgroundColor=ffe7f3&hairColor=1e1e1e&clothesColor=be185d&clothesType=blazerShirt',
        'akebi hasegawa' => 'https://api.dicebear.com/9.x/avataaars/svg?seed=akebi-hasegawa&backgroundColor=ffe7f3&hairColor=1e1e1e&clothesColor=ec4899&clothesType=blazerShirt',
        'fumi honjo' => 'https://api.dicebear.com/9.x/avataaars/svg?seed=fumi-honjo&backgroundColor=ffe7f3&hairColor=1e1e1e&clothesColor=f472b6&clothesType=blazerShirt',
        'kana koyama' => 'https://api.dicebear.com/9.x/avataaars/svg?seed=kana-koyama&backgroundColor=ffe7f3&hairColor=1e1e1e&clothesColor=db2777&clothesType=blazerShirt',
    ];

    public const EXTERNAL_SOURCES = [
        'dicebear' => 'https://api.dicebear.com/7.x/avataaars/svg',
        'ui-avatars' => 'https://ui-avatars.com/api',
        'robohash' => 'https://robohash.org',
    ];

    /**
     * Get avatar URL for a user or character name
     */
    public function getAvatarUrl(?string $name, ?string $email = null, ?string $avatar = null): string
    {
        // 1. Keep valid remote avatar URLs usable without a local filesystem lookup.
        if ($avatar && filter_var($avatar, FILTER_VALIDATE_URL)) {
            return $avatar;
        }

        // 2. If user has custom uploaded avatar
        if ($avatar && (str_starts_with($avatar, 'avatars/') || str_contains($avatar, '/'))) {
            if (Storage::disk('public')->exists($avatar)) {
                return Storage::disk('public')->url($avatar);
            }
            if (file_exists(public_path($avatar))) {
                return asset($avatar);
            }
        }

        // 3. Check for known characters before generic presets so home avatars match names.
        if ($name) {
            $normalizedName = Str::lower(trim($name));

            // Remove parenthetical content like "(後藤 ひとり)"
            $cleanName = preg_replace('/\s*\([^)]+\)/', '', $normalizedName);

            if (isset(self::BOCCI_CHARACTERS[$cleanName])) {
                return self::BOCCI_CHARACTERS[$cleanName];
            }

            // Try fuzzy matching for partial names
            foreach (self::BOCCI_CHARACTERS as $charName => $url) {
                if (str_contains($cleanName, $charName) || str_contains($charName, $cleanName)) {
                    return $url;
                }
            }
        }

        // 4. Generate a deterministic remote avatar for every named user.
        // avoids making an HTTP request for every avatar rendered by the server.
        if ($name || $email) {
            $seed = $email ?: $name;
            return $this->getDiceBearAvatar($seed);
        }

        // 5. Keep local presets only as a fallback for anonymous components.
        if ($avatar && array_key_exists($avatar, User::AVATAR_PRESETS)) {
            return asset(User::AVATAR_PRESETS[$avatar]);
        }

        // 6. Default fallback
        return asset('images/bocchi.png');
    }

    /** Generate a deterministic DiceBear URL for a name or email address. */
    protected function getDiceBearAvatar(string $seed): string
    {
        return str_replace('/7.x/', '/9.x/', self::EXTERNAL_SOURCES['dicebear']) . '?' . http_build_query([
            'seed' => $seed,
            'backgroundColor' => 'ffe7f3',
            'hairColor' => '1e1e1e',
            'clothesColor' => 'ec4899',
            'radius' => 50,
        ]);
    }

    /**
     * Get avatar with progressive loading support (blur placeholder)
     */
    public function getAvatarData(?string $name, ?string $email = null, ?string $avatar = null, string $size = 'md'): array
    {
        $url = $this->getAvatarUrl($name, $email, $avatar);

        // Generate tiny blur placeholder (base64 encoded 10px version)
        $placeholder = $this->generatePlaceholder($url);

        return [
            'url' => $url,
            'placeholder' => $placeholder,
            'alt' => $name ?? 'User',
            'initials' => $this->getInitials($name),
        ];
    }

    /**
     * Generate initials from name
     */
    protected function getInitials(?string $name): string
    {
        if (!$name) return 'SH';

        $parts = preg_split('/\s+/', trim($name)) ?: [];
        $letters = collect($parts)
            ->filter()
            ->take(2)
            ->map(fn (string $part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');

        return $letters !== '' ? $letters : 'SH';
    }

    /**
     * Generate blur placeholder (tiny base64 image)
     */
    protected function generatePlaceholder(string $url): string
    {
        // Return a tiny transparent PNG base64 as placeholder
        // This will be replaced by the actual image via JS
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAFUlEQVR42mP8/5+hnoEIwDiqkL4KAcT9G0AB4Y9gZgABzQM2RIUFAAAAAElFTkSuQmCC';
    }
}
