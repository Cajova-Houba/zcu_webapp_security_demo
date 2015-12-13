# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure(2) do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  config.vm.box = "centos/7"

  config.vm.network "private_network", ip: "192.168.33.10"
  config.vm.synced_folder ".", "/opt/zcu_demo"#, type: "rsync"
  config.vbguest.auto_update = false

  config.vm.provision "shell", inline: <<-SHELL
    # sudo yum -y update
    # sudo yum -y install httpd
    # sudo systemctl enable httpd.service
    # sudo yum -y install mariadb-server mariadb
    # sudo systemctl enable mariadb.service
    # sudo yum -y install php php-mysql
    # sudo yum clean all
    mysql -u root < /opt/zcu_demo/db/create_db.ddl
    mysql -u root zcu_demo < /opt/zcu_demo/db/init_data.dml
    sudo cp /opt/zcu_demo/www/index.php /var/www/html/
  SHELL
end
