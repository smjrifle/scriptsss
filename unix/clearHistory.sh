#!/bin/zsh
rm ~/.local/share/recently-used.xbel
touch ~/.local/share/recently-used.xbel
rm ~/.local/share/zeitgeist/activity.sqlite 
#zeitgeist-daemon --replace
