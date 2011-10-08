<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// for three-seas.com

// for pcsenegal.org
$config['upload_path'] = 'uploads';
$config['allowed_types'] = 'gif|jpg|png';
$config['max_size']	= '0';
$config['max_width']  = '0';
$config['max_height']  = '0';
$config['file_name'] = md5(time().rand());