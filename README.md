silverstripe-facedetection
==========================

SilverStripe module to add face detection to images

## Overview

This module allows adding simple PHP-based face detection to images.  Using a template tag, you can output an image that has an overlaid square indicating a detected face:

> $Image.FaceDetection

It uses the PHP Face_Detector class by Maurice Svay, ported from a JavaScript class by Karthik Tharavaad:
https://github.com/mauricesvay/php-facedetection

## Installation

Download, place the folder in your project root and run dev/build?flush=1.
