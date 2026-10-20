"""Build a clean, uploadable WordPress theme archive."""
from pathlib import Path
from zipfile import ZipFile, ZIP_DEFLATED
root = Path(__file__).resolve().parents[1]
out = root / 'dist/i9nove-digital.zip'
out.parent.mkdir(exist_ok=True)
with ZipFile(out, 'w', ZIP_DEFLATED) as archive:
    for name in ['style.css', 'theme.json', 'functions.php', 'README.md', 'CREDITS.md', 'LICENSE', 'screenshot.png']:
        archive.write(root / name, 'i9nove-digital/' + name)
    for folder in ['assets', 'parts', 'patterns', 'templates']:
        for path in sorted((root / folder).rglob('*')):
            if path.is_file():
                archive.write(path, 'i9nove-digital/' + str(path.relative_to(root)))
print(out)
