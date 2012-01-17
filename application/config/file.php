<?php
#   Copyright (c) 2011, John F. Brown  This file is
#   licensed under the Affero General Public License version 3 or later.  See
#   the COPYRIGHT file.

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['upload_path'] = 'uploads/docs';
$config['allowed_types'] = 'pdf|txt|md|csv|mp3|ppt';
$config['max_size']	= '0';
$config['file_name'] = md5(time().rand());
