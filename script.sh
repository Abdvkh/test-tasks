#!/bin/bash

while true; do
	begin=`date +%s`
	php ~/script-auto-run/script.php
	end=`date +%s`
	if [ $(($end - $begin )) -lt 20 ]; then
		sleep $(($begin + 20 - $end))
	fi
done
