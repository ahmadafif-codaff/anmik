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

![anmik-dashboard](https://github.com/ahmadafif-codaff/master-img/assets/146537873/69e133c4-f669-4903-8f7b-d80608f9f8e6)

3. On the ANMIK web server, click the ip/dhcp-lease menu and all connected client routers will be displayed. (Please note that the connected client router must be connected to the Mikrotik router in router hotspot mode and by getting the IP dynamically. This is used to find out which routers are on and off).

![anmik-dhcp-lease](https://github.com/ahmadafif-codaff/master-img/assets/146537873/f12c635e-399c-4241-a9b0-a9014ff59bb0)

4. Still on the ip/dhcp page, if youre router client get IP dynamically (marked with a yellow background), click button check, then status will be changed to static ip (marked with a white background). This is used to prevent the IP address from being used by other client routers.

![anmik-static-dhcp-lease](https://github.com/ahmadafif-codaff/master-img/assets/146537873/b3e91a16-9855-4e3a-8dd4-74e830f4892a)

5. Then move to the firewall page by clicking ip/firewall menu, click generate firewall button to quickly create the firewall. This is used to block internet access for unauthorized IP addresses.

![anmik-firewall](https://github.com/ahmadafif-codaff/master-img/assets/146537873/dc4ade8b-7491-44f5-b0e4-f5a393ac4a52)

Update on firewall :
You can see the client using the IP in the firewall list
 
![anmik-firewall-client-name](https://github.com/ahmadafif-codaff/master-img/assets/146537873/9145c1cb-247b-4529-b0b5-fa2937c546fc)

6. Open the package page and make a package according to what will be used.

![anmik-paket](https://github.com/ahmadafif-codaff/master-img/assets/146537873/8f0b4eac-856d-4718-8846-ecce15201ca8)

7. Make client with clicking client menu, then create a client according to the client router IP and the package the client will use. When you first create a client, the system will direct you to create a client with the name Root Simple Queue, just change the date and package, then click OK, the root client will not be recorded in the ANMIK application, but will only be recorded in the Simple Queue in MIKROTIK.

![Screenshot 2024-02-12 at 10 40 48](https://github.com/ahmadafif-codaff/master-img/assets/146537873/7a2eaf24-8abe-46b9-a8ef-cf5371abd672)

![anmik-client](https://github.com/ahmadafif-codaff/master-img/assets/146537873/ea4871c0-8a98-492a-8184-d8dcca907532)

If remote management on your client router is active, then you can do it remotely by simply clicking on the IP address that is in the client list or dhcp lease list

![anmik-client-router](https://github.com/ahmadafif-codaff/master-img/assets/146537873/5aa4f75c-ece7-4154-879a-6783b54ddce7)

8. Go to the schedule reboot page to make the router reboot on a scheduled basis. This schedule is divided into 2 types, namely day and hour.

![anmik-schedule-reboot](https://github.com/ahmadafif-codaff/master-img/assets/146537873/e7704ab1-62fc-4df8-9ce1-3b17cbc8336c)

9. On the schedule boost page, it is used to create a predetermined client speed increase schedule. This schedule is divided into 2 types, namely repeat and one time.

![anmik-schedule-boost](https://github.com/ahmadafif-codaff/master-img/assets/146537873/a697bd05-db4a-4b9c-bfd8-a14847fc7482)

10. Press the Mikrotik reboot menu button to reboot the Mikrotik from the web server.

![anmik-reboot](https://github.com/ahmadafif-codaff/master-img/assets/146537873/03f7fbb7-86ea-437d-be22-180619d15a97)

11. Click the logging menu button to display the activity log. Here all activities will be shown, both data changes made by the admin or from the server itself.

![anmik-log](https://github.com/ahmadafif-codaff/master-img/assets/146537873/4cf8f2c3-c5ab-4a5c-953c-950b3c91a140)


# Update

2.1.0 Your customers can see the selected packages and can see their quota usage.

1. Open the web browser then follow links http://localhost/anmik/login_client ("anmik" change to directory where you place master file). You will be directed to the login page.

2. To log in to the client, use the client name as the username and the target IP as the password.

![anmik-username-password](https://github.com/ahmadafif-codaff/master-img/assets/146537873/74c2ead6-1b34-4d16-80c6-6975e99665d9)

![anmik-client-login](https://github.com/ahmadafif-codaff/master-img/assets/146537873/1fb43fa7-6eca-4f36-930d-2d2d6871cc3d)

3. Then, if login correctly you will be directed to the client dashboard page.

![anmik-dashboard-client](https://github.com/ahmadafif-codaff/master-img/assets/146537873/38e34355-a73b-425c-a52b-b47afbc88743)
