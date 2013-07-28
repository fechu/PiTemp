#PiTemp

A simple script that monitors your Raspberry Pi's temperature.

----

![Example Photo](img/Example.png)

##Installation

Before you can start monitoring your Pis temperature in your webbrowser you need to install a webserver with PHP. I use a LAMP setup. Follow one of the many guides like [this](http://www.dingleberrypi.com/2012/09/tutorial-install-apache-php-and-mysql-on-raspberry-pi/) or [this](http://www.wikihow.com/Make-a-Raspberry-Pi-Web-Server) to setup your Raspberry Pi as a webserver. 

If you have installed git on your Raspberry you can easily clone the repo into the webroot of your webserver. 

	// Example is for apache only. 
	// Replace /var/www/ with the webroot of your webserver
	cd /var/www
	git clone https://github.com/fechu/PiTemp
	
The Next thing is to setup cron to execute the `monitor.php` script every 15 minutes to write down the temperature. You do this by modifing the file `/etc/crontab` like this:

	sudo nano /etc/crontab

Add the following line to the end of the file.

	*/15 *  * * *   root    /var/www/monitor/monitor.php
	
This tells cron to execute the script every 15 minutes of an hour. `root` is the user that executes the script. and `/var/www/monitor/monitor.php` is the script that is executed.

That's it! Now you need to wait for your script to collect data. Once you can't wait anymore open your browser (the computer has to be connected to the same network as the Raspberry Pi) and navigate to `http://<Your Pi's IP>/monitor`.

##Todo

- Support temperature display in F&deg;
- Support multiple Raspberry Pi
- Select Timespan
- Use Sqlite/Mysql database instead of textfile

##Libraries

This project uses the following libraries or parts of them:

- Flot ([flotcharts.org](https://www.flotcharts.org)) Released under [MIT License](http://opensource.org/licenses/MIT)
- Twitter Bootstrap ([twitter.github.io/bootstrap/](https://twitter.github.io/bootstrap)) Released under [Apache License Version 2.0](http://www.apache.org/licenses/LICENSE-2.0)
- jQuery ([jquery.com](http://jquery.com)) Released under [MIT License](http://opensource.org/licenses/MIT)


##License

The MIT License (MIT)

Copyright (c) 2013 Sandro Meier

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.