"""Package the standalone Elementor theme, without dev files or the plugin."""
from pathlib import Path
from zipfile import ZipFile, ZIP_DEFLATED
root = Path(__file__).resolve().parents[1]
source = root / 'elementor-theme'
out = root / 'dist/i9nove-elementor.zip'
out.parent.mkdir(exist_ok=True)
with ZipFile(out, 'w', ZIP_DEFLATED) as archive:
    for path in sorted(source.rglob('*')):
        if path.is_file():
            archive.write(path, 'i9nove-elementor/' + str(path.relative_to(source)))
print(out)
