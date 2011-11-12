# Peace Corps App README

## Description

This is an under-development web application for Peace Corps posts, written in PHP with a MySQL database, on the CodeIgniter framework. It serves external content in the form of pages (like a traditional site) but also utilizes a Facebook-based user authentication system to allow the sharing of contact information and private resources. It's currently stable but buggy and has no installer. If interested in working with it, please contact its developer.

The big reasons I encourage all PC posts to try it are

1. the more sites running it, the faster we'll get it running stably
2. the next step is to get all installed instances communicating with one another, allowing seamless resource sharing and user directories.

I want it to function like one big social resource repository, but without any central oversight. I want sites to be able to go down without impacting the whole, and I want everyone to be able to use their installation of it independently.

## Known Issues

* Requires users have Facebook (coming soon: OpenID support)
* No installer (easy config, but must be done by hand)
* Weak support for bulk editing/creating users. It exists, but is not robust.
* This is under-development software. Bugs are continually located and corrected.

## Features

I just launched the production version of the app. It's now live at [pcsenegal.org](http://pcsenegal.org). What it does:

* Authentication by Facebook, so all that's required is a list of approved emails and permission settings.
* Common user table (names, emails, phones, address, etc.) plus specialized auxiliary tables for:
	* Volunteers & RPCVs (COS, site, etc)
	* Staff (job, hire date, etc)
	* Group based permissions
* Allows uploading of:
	* photos
	* docs
	* links
	* video (embedded)
* Supports in-browser, wiki-style creation and editing of:
	* pages
	* case studies
* All resources support #hashtagging, and are auto-linked to one another based on common tags. The menu structure for pages is auto-generated based on parent relationships. Pages & case studies (which are really just specialized pages) support either Markdown formatting or HTML (or both, intermingled)
* All users have a profile page, which they can edit, and if they have a blogspot blog it can be viewed in the site.
* Update feed for any/all types of resources

## Coming Soon

* User-uploaded resources
* Web-based installer
* Better in-site search tools
* OpenID Authentication

## Requirements

The following is an inexhaustive list of requirements to run this application:

* PHP
* SQL server supporting Active Record queries
* Facebook App ID and Security Code
* Facebook accounts for all users