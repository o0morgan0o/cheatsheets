# (slug: snapshot-website) Snapshot Website

google-chrome --headless --screenshot="myscreenshot.png" https://www.baeldung.com/
pipx install shot-scraper
shot-scraper install
shot-scraper https://<site>.com -h 900 --wait 2000
shot-scraper https://<site>.com -h 900 --interactive # and hit enter in terminal to take screenshot
shot-scraper https://<site>.com -h 900 --log-requests -
shot-scraper https://<site>.com -h 900 --user-agent TEXT
