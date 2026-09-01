<?php
/**
     * Generateplaceholder.
     *
     * @return protected generatePlaceholder
     */

    /**
     * Getinitials.
     *
     * @return protected getInitials
     */

    /**
     * Getavatardata.
     *
     * @return public getAvatarData
     */

    /**
     * Getavatarurl.
     *
     * @return public getAvatarUrl
     */


namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AvatarService
{
    public const BOCCI_CHARACTERS = [
        'hitori gotoh' => 'https://api.dicebear.com/9.x/bottts/svg?seed=hitori-gotoh&backgroundColor=ffe7f3',
        'ikuyo kita' => 'https://api.dicebear.com/9.x/icons/svg?seed=ikuyo-kita&backgroundColor=fce7f3',
        'nijika ijichi' => 'https://api.dicebear.com/9.x/shapes/svg?seed=nijika-ijichi&backgroundColor=f3e8ff',
        'ryo yamada' => 'https://api.dicebear.com/9.x/identicon/svg?seed=ryo-yamada&backgroundColor=e0f2fe',
        'seika ijichi' => 'https://api.dicebear.com/9.x/thumbs/svg?seed=seika-ijichi&backgroundColor=dcfce7',
        'futari gotoh' => 'https://api.dicebear.com/9.x/fun-emoji/svg?seed=futari-gotoh&backgroundColor=ffe7f3',
        'yoyoko ohtsuki' => 'https://api.dicebear.com/9.x/rings/svg?seed=yoyoko-ohtsuki&backgroundColor=fce7f3',
        'eliza shimizu' => 'https://api.dicebear.com/9.x/bottts/svg?seed=eliza-shimizu&backgroundColor=e0f2fe',
        'shima iwashita' => 'https://api.dicebear.com/9.x/icons/svg?seed=shima-iwashita&backgroundColor=f3e8ff',
        'akebi hasegawa' => 'https://api.dicebear.com/9.x/shapes/svg?seed=akebi-hasegawa&backgroundColor=dcfce7',
        'fumi honjo' => 'https://api.dicebear.com/9.x/identicon/svg?seed=fumi-honjo&backgroundColor=ffe7f3',
        'kana koyama' => 'https://api.dicebear.com/9.x/thumbs/svg?seed=kana-koyama&backgroundColor=fce7f3',
    ];

    public const EXTERNAL_SOURCES = [
        'dicebear' => 'https://api.dicebear.com/9.x/bottts/svg',
        'ui-avatars' => 'https://ui-avatars.com/api',
        'robohash' => 'https://robohash.org',
    ];

    public const NON_HUMAN_STYLES = [
        'bottts',
        'icons',
        'shapes',
        'identicon',
        'thumbs',
        'fun-emoji',
        'rings',
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

        // 2. If user has custom uploaded avatar or relative path
        if ($avatar && (str_starts_with($avatar, 'avatars/') || str_starts_with($avatar, 'images/') || str_contains($avatar, '/'))) {
            if (Storage::disk('public')->exists($avatar)) {
                return route('avatar.show', ['filename' => basename($avatar)]);
            }
            if (file_exists(public_path($avatar))) {
                return asset($avatar);
            }
        }

        // 3. Preset avatar explicitly selected by user (bocchi, bocchi-shy, bocchi-maid, etc.)
        if ($avatar && array_key_exists($avatar, User::AVATAR_PRESETS)) {
            $preset = User::AVATAR_PRESETS[$avatar];
            if (filter_var($preset, FILTER_VALIDATE_URL)) {
                return $preset;
            }
            return asset($preset);
        }

        // 4. Check for known characters before generic presets so home avatars match names.
        if ($name) {
            $normalizedName = Str::lower(trim($name));

            // Remove parenthetical content like "(後藤 ひとり)"
            $cleanName = preg_replace('/\s*\([^)]+\)/', '', $normalizedName);

            if (isset(self::BOCCI_CHARACTERS[$cleanName])) {
                $charUrl = self::BOCCI_CHARACTERS[$cleanName];
                return filter_var($charUrl, FILTER_VALIDATE_URL) ? $charUrl : asset($charUrl);
            }

            // Try fuzzy matching for partial names
            foreach (self::BOCCI_CHARACTERS as $charName => $url) {
                if (str_contains($cleanName, $charName) || str_contains($charName, $cleanName)) {
                    return filter_var($url, FILTER_VALIDATE_URL) ? $url : asset($url);
                }
            }
        }

        // 5. Generate a deterministic remote avatar for every named user.
        if ($name || $email) {
            $seed = $email ?: $name;
            return $this->getDiceBearAvatar($seed);
        }

        // 6. Default fallback (remote internet avatar)
        return User::AVATAR_PRESETS[User::DEFAULT_AVATAR];
    }

    public const CARICATURE_STYLES = [
        'adventurer',
        'micah',
        'lorelei',
        'bottts',
        'big-smile',
        'croodles',
        'open-peeps',
        'personas',
        'fun-emoji',
        'icons',
    ];

    /** Generate a deterministic instant local SVG Data URI avatar with matching palette. */
    protected function getDiceBearAvatar(string $seed): string
    {
        $hash = abs(crc32($seed));
        $bgColors = ['#fce7f3', '#e0f2fe', '#fef3c7', '#dcfce7', '#f3e8ff', '#ffe4e6'];
        $textColors = ['#be185d', '#0369a1', '#b45309', '#15803d', '#7e22ce', '#e11d48'];
        $idx = $hash % count($bgColors);
        $bg = $bgColors[$idx];
        $text = $textColors[$idx];

        // Clean initial letters from seed
        $clean = preg_replace('/[^a-zA-Z0-9]/', '', $seed);
        $initials = mb_strtoupper(mb_substr($clean !== '' ? $clean : $seed, 0, 2));

        $svg = "<svg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'><circle cx='50' cy='50' r='50' fill='{$bg}'/><text x='50' y='55' font-family='Plus Jakarta Sans, Inter, sans-serif' font-size='36' font-weight='800' fill='{$text}' text-anchor='middle' dominant-baseline='middle'>{$initials}</text></svg>";

        return 'data:image/svg+xml;utf8,' . rawurlencode($svg);
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
