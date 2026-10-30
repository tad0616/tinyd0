#!/bin/sh
for file in tinycontent[0-9]_index.html; do cp -a tinycontent_index.html $file; done
for file in tinycontent[0-9]_print.html; do cp -a tinycontent_print.html $file; done
for file in blocks/tinycontent[0-9]_nav_block.html; do cp -a blocks/tinycontent_nav_block.html $file; done
