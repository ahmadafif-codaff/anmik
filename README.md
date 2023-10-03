# ANMIK
Mikrotik Local Bandwidth Management System, Using Mikrotik API

This software is for a local bandwidth management system using the Mikrotik API. Bandwidth management is targeted for each IP address obtained from Mikrotik DHCP, using a simple queue method.

# Features
1. Generate Firewall filter rule.
2. Make package for client (category for package : Premium, Regular, Kuota).
3. Make client using simple queue method.
4. Bandwidth management.
5. Client usage graph.
6. Reboot Mikrotik.

# Requirement
If you want to use this software, the requirements :
- Web Server
1. Operating System (Linux is Recomended).
2. PHP version >= 7.4.
3. Apache web server or similar.
4. Enable htaccess.
5. MySQL DBMS.
- Mikrotik Router board
1. Clock speed CPU 650 MHz.
2. Router OS v6.3.
3. Enable API port.

# Installation
For instalation follow this :
1. Get ANMIK master. You can get the master file with :
   - Download ANMIK master package [ANMIK](https://github.com/ahmadafif-codaff/anmik/archive/refs/heads/master.zip) then extract at web server folder or
   - Open terminal in your web server directory then clone this repository with :
   ```shel
   git clone https://github.com/ahmadafif-codaff/anmik.git
   ```
2. Edit file example.config.php in "app/config" folder, fill in the DB_HOST, DB_USER, DB_PASSWORD according to your DBMS, and fill in MIKROTIK_HOST, MIKROTIK_USER, MIKROTIK_PASSWORD according to your Mikrotik Router, then save the change and rename file example.config.php to config.php.
3. Make database "anmik" then import database anmik.sql from "db" folder.
4. Open the web browser, then follow links http://localhost/anmik/autoinput ("anmik" change to directory where you place master file). Every time your PC restart run this link (make the link is autorun is recomended).

# How to use?
If the web server has been installed correctly, then :
1. Open the web browser then follow links http://localhost/anmik/login ("anmik" change to directory where you place master file). You will be directed to the login page.
2. Login to ANMIK using username : anmik, and password : Anmik123. If login correctly you will be directed to the dashboard page.
3. On the ANMIK web server, click the ip/dhcp-lease menu and all connected client routers will be displayed. (Please note that the connected client router must be connected to the Mikrotik router in router hotspot mode and by getting the IP dynamically. This is used to find out which routers are on and off).
4. Still on the ip/dhcp page, if youre router client get IP dynamically (marked with a yellow background), click button check, then status will be changed to static ip (marked with a white background). This is used to prevent the IP address from being used by other client routers.
5. Then move to the firewall page by clicking ip/firewall menu, click generate firewall button to quickly create the firewall. This is used to block internet access for unauthorized IP addresses.
6. Open the package page and make a package according to what will be used.
7. Make client with clicking client menu, then create a client according to the client router IP and the package the client will use.



