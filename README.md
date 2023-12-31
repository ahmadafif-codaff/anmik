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
![anmik-dashboard](https://github.com/ahmadafif-codaff/master-img/assets/146537873/52728234-8ee1-49a7-b837-d598b73e9d24)
3. On the ANMIK web server, click the ip/dhcp-lease menu and all connected client routers will be displayed. (Please note that the connected client router must be connected to the Mikrotik router in router hotspot mode and by getting the IP dynamically. This is used to find out which routers are on and off).
![anmik-dhcp-lease](https://github.com/ahmadafif-codaff/master-img/assets/146537873/498113f1-a71e-4971-a661-0d0874310487)
4. Still on the ip/dhcp page, if youre router client get IP dynamically (marked with a yellow background), click button check, then status will be changed to static ip (marked with a white background). This is used to prevent the IP address from being used by other client routers.
5. Then move to the firewall page by clicking ip/firewall menu, click generate firewall button to quickly create the firewall. This is used to block internet access for unauthorized IP addresses.
![anmik-firewall](https://github.com/ahmadafif-codaff/master-img/assets/146537873/dc4ade8b-7491-44f5-b0e4-f5a393ac4a52)
6. Open the package page and make a package according to what will be used.
![anmik-paket](https://github.com/ahmadafif-codaff/master-img/assets/146537873/8f0b4eac-856d-4718-8846-ecce15201ca8)
7. Make client with clicking client menu, then create a client according to the client router IP and the package the client will use.
![anmik-client](https://github.com/ahmadafif-codaff/master-img/assets/146537873/da519282-b4e6-4405-a624-904055b636fc)
8. Go to the schedule reboot page to make the router reboot on a scheduled basis. This schedule is divided into 2 types, namely day and hour.
![anmik-schedule-reboot](https://github.com/ahmadafif-codaff/master-img/assets/146537873/e7704ab1-62fc-4df8-9ce1-3b17cbc8336c)
9. On the schedule boost page, it is used to create a predetermined client speed increase schedule. This schedule is divided into 2 types, namely repeat and one time.
![anmik-schedule-boost](https://github.com/ahmadafif-codaff/master-img/assets/146537873/a697bd05-db4a-4b9c-bfd8-a14847fc7482)
10. Press the Mikrotik reboot menu button to reboot the Mikrotik from the web server.
![anmik-reboot](https://github.com/ahmadafif-codaff/master-img/assets/146537873/03f7fbb7-86ea-437d-be22-180619d15a97)
11. Click the logging menu button to display the activity log. Here all activities will be shown, both data changes made by the admin or from the server itself.
![anmik-log](https://github.com/ahmadafif-codaff/master-img/assets/146537873/4cf8f2c3-c5ab-4a5c-953c-950b3c91a140)



