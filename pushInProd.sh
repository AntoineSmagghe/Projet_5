#!/bin/sh
rsync -4rvhz --delete-after --exclude=env.local ~/Documents/Symfony/CDLM/ antoine@cdlm.space:/var/www/CDLM/
