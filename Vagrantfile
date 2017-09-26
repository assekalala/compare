# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.hostname = "tutuka-transactionscompare"

  config.vm.network "forwarded_port", guest: 80, host: 8000
  config.ssh.forward_agent = true
  config.vm.synced_folder "./code", "/home/vagrant/code"
  config.vm.provision "file", source: "compare.conf", destination: "/tmp/compare.conf"
  config.vm.provision "shell", path: "./provisioner"
end
