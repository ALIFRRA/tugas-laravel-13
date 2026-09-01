import re
with open('c:/wamp64/www/hasilsetres/routes/web.php', 'r') as f:
    content = f.read()
lines = content.split('\n')

# Join lines that are part of multi-route definitions
# A route definition starts with Route:: and may have continuation lines starting with ->
joined_lines = []
i = 0
while i < len(lines):
    line = lines[i].strip()
    if not line or line.startswith('//'):
        i += 1
        continue
    # If line starts with Route::, it's a new route
    # Check if it's a complete single-line route or starts a multi-line one
    if line.startswith('Route::'):
        # Collect the full route definition - include following lines that start with ->
        route_lines = [line]
        j = i + 1
        while j < len(lines):
            next_line = lines[j].strip()
            if next_line.startswith('->') or next_line.startswith('->') and ('middleware' in next_line or 'name' in next_line or 'where' in next_line):
                route_lines.append(next_line)
                j += 1
            else:
                break
        joined_lines.append(' '.join(route_lines))
        i = j
    else:
        i += 1

routes = []
for jl in joined_lines:
    m = re.match(r'Route::([a-z]+)\s+\((.+?)\)', jl)
    if m:
        method = m.group(1)
        lc = m.group(2)
        prefix = re.search(r"prefix\('([^']+)'\)", lc)
        middleware = re.search(r'->middleware\((.*?)\)', lc)
        name = re.search(r"->name\('([^']+)'\)", lc)
        url = re.search(r"['\"]([^'\"]+)'[\"]", lc)
        pattern = url.group(1) if url else None
        routes.append({
            'method': method, 'pattern': pattern,
            'prefix': prefix.group(1) if prefix else None,
            'middleware': middleware.group(1) if middleware else None,
            'name': name.group(1) if name else None,
            'raw': lc[:200]
        })

# Table header
fmt = "{:>5} {:<8} {:<30} {:<12} {:<25} {:<25}"
print(fmt.format("LINE", "METHOD", "PATTERN", "PREFIX", "MIDDLEWARE", "NAME"))
print("-" * 100)
for idx, r in enumerate(routes):
    print(fmt.format(
        routes.index(r, idx) if False else idx+1, r['method'], r['pattern'] or 'N/A',
        r['prefix'] or '', r['middleware'] or '', r['name'] or ''
    ))

print(f"\nTotal routes: {len(routes)}")

api_routes = [r for r in routes if r['pattern'] and r['pattern'].startswith('/api')]
web_routes = [r for r in routes if r['pattern'] and not r['pattern'].startswith('/api')]
print(f"\nAPI routes: {len(api_routes)}")
for r in api_routes:
    print(f"  {r['pattern']} -> {r['name']} ({r['method']}) [mw: {r['middleware']}]")

print(f"\nWeb routes: {len(web_routes)}")
for r in web_routes[:15]:
    print(f"  {r['pattern']} -> {r['name']}")

resource_routes = [r for r in routes if 'resource' in r['raw'].lower()]
print(f"\nResource patterns: {len(resource_routes)}")
for r in resource_routes:
    print(f"  {r['raw'][:150]}")

mw_counts = {}
for r in routes:
    if r['middleware']:
        mw = r['middleware']
        mw_counts[mw] = mw_counts.get(mw, 0) + 1
print(f"\nMiddleware usage:")
for mw, cnt in sorted(mw_counts.items(), key=lambda x: -x[1]):
    print(f"  {mw}: {cnt}")