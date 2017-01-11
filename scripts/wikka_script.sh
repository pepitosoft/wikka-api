#!/bin/bash

URL="http://172.17.0.2/wikka/wikka-api/public/index.php"

TABLES="
acls
comments
links
pages
referrerblacklist
referrers
sessions
users
"

for i in $TABLES; do http GET "$URL/$i"; done
