# Package the Niswah Boutique child theme. The zip is written by build/pack.py:
# WordPress rejected zips produced by System.IO.Compression ("missing style.css")
# on 2026-09-04 and 2026-09-07, while Python zipfile output installs fine.
#
# Usage:  powershell -ExecutionPolicy Bypass -File build\pack.ps1
$ErrorActionPreference = 'Stop'
python (Join-Path $PSScriptRoot 'pack.py')
if ($LASTEXITCODE -ne 0) { throw "pack.py failed" }
