# Installing the virtual development machine

## Install Vagrant (HashiCorp)
_Vagrant by HashiCorp is a piece of software that enables you to automatically launch and provision virtual machines on different hypervisor providers using simple scripts._

Download installation file here (pick the one that matches your host machine environment):

    https://www.vagrantup.com/downloads.html (tested with 1.9.4)
    
## Install VirtualBox (Oracle)
_VirtualBox from Oracle is a virtual machine hypervisor, i.e. a piece of software that is able to simulate an complete computer._

Download installation file here (pick the one that matches your host machine environment):

    https://www.virtualbox.org/wiki/Downloads (tested with 5.1.22)
    
## Clone the jot repository to a suitable location on your host machine

    https://github.com/jgivoni/jot
    
## Edit VagrantUserconfig

Enter the directory where you cloned jot and continue into the system/vagrant/devbox subdirectory.

* Modify `app_dir` and specify the path to where you cloned the jot repository
* Optionally modify the IP address, or take a note of it so you can update your hosts file

## Edit hosts file on you host machine
_The hosts file enables your computer to find websites that do not have a public DNS entry_

Depending on your host machine environment, find and edit the hosts file:

    Windows: C:\Windows\System32\Drivers\etc\hosts
    
    Others: /etc/hosts
    
Add the IP address found in the VagrantUserconfig file (vm_ip setting), followed by the host name:

    192.168.12.145 jotzone.local
        
## Start the virtual machine

To launch the virtual development matchine, execute the following command from the jot/system/vagrant/devbox directory

    vagrant up
    
## Visit the jot local development website
If everything went well you should now be able to load the website login page by going to the following address in your browser on the host machine:

    http://jotzone.local/

## --------------------------------------------

### Debugging
You can find error messages in the following files inside the Vagrant box:
    
    /var/log/httpd/error_log
    /var/log/php-fpm/error.log
    /var/log/php-fpm/www-error.log
