#!/bin/bash
echo "🔍 Checking if you uploaded images..."
cd /home/rami/Desktop/linkat-main
php artisan theme:check-images --store=all
