"""Serve client-products/images/ on http://localhost:8765 with CORS headers.

Used once, during the Media Library upload: the logged-in WordPress admin tab
fetches each JPG from here (browsers treat localhost as a secure origin, so an
https page may read it) and posts it to /wp-json/wp/v2/media. Nothing else
needs this server. Ctrl+C to stop.
"""
import os, sys
from http.server import SimpleHTTPRequestHandler, ThreadingHTTPServer

ROOT = os.path.abspath(os.path.join(os.path.dirname(__file__), '..', '..', 'client-products', 'images'))
PORT = int(sys.argv[1]) if len(sys.argv) > 1 else 8765

class H(SimpleHTTPRequestHandler):
    def __init__(self, *a, **k):
        super().__init__(*a, directory=ROOT, **k)
    def end_headers(self):
        self.send_header('Access-Control-Allow-Origin', '*')
        self.send_header('Access-Control-Allow-Headers', '*')
        self.send_header('Cache-Control', 'no-store')
        super().end_headers()
    def do_OPTIONS(self):
        self.send_response(204); self.end_headers()
    def log_message(self, *a):
        pass

print(f'serving {ROOT} on http://localhost:{PORT}/', flush=True)
ThreadingHTTPServer(('127.0.0.1', PORT), H).serve_forever()
