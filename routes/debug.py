import re
with open('c:/wamp64/www/hasilsetres/routes/web.php', 'r') as f:
    content = f.read()
lines = content.split('\n')

# Just print the first 10 lines with their content
for idx, line in enumerate(lines[:15]):
    print(f"{idx}: '{line}'")

# Now try the joining
joined_lines = []
i = 0
while i < len(lines):
    line = lines[i].strip()
    if not line or line.startswith('//'):
        i += 1
        continue
    if line.startswith('Route::'):
        route_lines = [line]
        j = i + 1
        while j < len(lines):
            next_line = lines[j].strip()
            if next_line.startswith('->'):
                route_lines.append(next_line)
                j += 1
            else:
                break
        joined_lines.append(' '.join(route_lines))
        print(f"Joined: {' '.join(route_lines)[:100]}")
        i = j
    else:
        i += 1

print(f"\nTotal joined: {len(joined_lines)}")