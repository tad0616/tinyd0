#!/bin/sh
for file in tinycontent[0-9]_index.tpl; do cp -a tinycontent_index.tpl $file; done

for file in tinycontent[0-9]_print.tpl; do cp -a tinycontent_print.tpl $file; done

for file in blocks/tinycontent[0-9]_nav_block.tpl; do cp -a blocks/tinycontent_nav_block.tpl $file; done
