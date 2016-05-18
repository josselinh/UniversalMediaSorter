<?php

$inputFormats = array(
    '%year%/%month%/%day%/IMG_%year%%month%%day%_%hour%%minute%%second%.jpg',
    'IMG_%year%%month%%day%_%hour%%minute%%second%.jpg',
    'VID_%year%%month%%day%_%hour%%minute%%second%.mp4',
    '%year%%month%%day%_%hour%%minute%%second%.jpg',
    'GO%anything%.jpg'
);

$outputFormats = array(
    'jpg' => '%year%/%month%/%day%/IMG_%year%%month%%day%_%hour%%minute%%second%.jpg',
    'mp4' => '%year%/%month%/%day%/VID_%year%%month%%day%_%hour%%minute%%second%.mp4'
);
