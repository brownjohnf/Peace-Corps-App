# Peace Corps App README

This is an under-development web application for Peace Corps posts, written in PHP with a MySQL database, on the CodeIgniter framework. It serves external content in the form of pages (like a traditional site) but also utilizes a Facebook-based user authentication system to allow the sharing of contact information and private resources. It's currently highly unstable and has no installer. If interested in working with it, please contact its developer.

## Features

I just launched the production version of the app. It's now live at our main domain (http://pcsenegal.org). What it does:

Authentication is handled by Facebook, so all that's required is a list of approved emails and permission settings.

Maintains DB tables for:
Volunteers & RPCVs (COS, site, etc)
Staff (job, hire date, etc)
Locals (location, description)
Guests (name, email)

Permissions are very isolated. Everyone has a record for emails, phones, address, names, blog.

It hosts:

photos
docs
links
video (embedded)
pages
case studies

Pages and case studies are editable like a wiki, through a page on the site, with user control. All resources support #tagging, and are auto-linked to one another based on common tags. The menu structure for pages is auto-generated based on parent relationships. Pages & case studies (which are really just specialized pages) support either Markdown formatting or HTML (or both, intermingled).

All users have a profile page, which they can edit, and if they have a blogspot blog it can be viewed in the site.

Updates for all the above resources are tracked, and used to generate feeds for most recently updated ____ (whatever you're interested in). Same with tags.

Right now the weakest part of the site is bulk user management (it exists, but I've really only used it once, to set the thing up the first time, so it's not very robust) and installation. There's currently no install script. Configuration is dead easy (create the databases from SQL export, change about 5 lines of code), but by hand. Install script is in the pipes. It's also still in beta, and I'm cleaning things up every day. The big reasons I encourage everyone to try it are 1) the more sites running it, the faster we'll get it running stably and 2) the next step is to get all installed instances communicating with one another, allowing seamless resource sharing and user directories. I want it to function like one big social resource repository, but without any central oversight. I want sites to be able to go down without impacting the whole, and I want everyone to be able to use their installation of it independently.

## Requirements

The following is an inexhaustive list of requirements to run this application:

* PHP
* SQL server supporting Active Record queries
