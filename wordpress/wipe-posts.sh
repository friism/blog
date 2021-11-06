#! /bin/sh

wp post delete --force $(wp post list --post_type='page,post' --format=ids)
