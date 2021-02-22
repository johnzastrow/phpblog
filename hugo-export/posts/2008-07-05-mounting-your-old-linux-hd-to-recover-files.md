---
title: Mounting your old linux HD to recover files
categories:
  - Linux

---
A quickie lesson in mounting &#8211; If I have an old linux drive with stuff  
on it that I want to use in another linux system (and I do), these are  
the steps that I would follow. I would use the SLAVE, MASTER, CABLE  
SELECT jumper on the harddrive to set the set the drive to be a slave,  
and boot up my new linux install on another physical drive set to be  
master. I closely watch the boot messages, or try going to a place like  
/var/log/dmesg to see what hdX (e.g., hda, hdb, hdc) my old drive was  
assigned at boot. Partitions on that physical drive get numbers. With  
four partitions on my old drive, the root partition on my second drive  
was at hdd4. So, I needed to create a mount point to mount my drive to.  
For simplicity, I chose to mkdir /mnt/hdd4. 

/mnt/hdd4. I could then cd to /mnt/hdd4 and copy off my files. If I  
wanted to reboot with the partition mounted, simply I would just add  
something like /dev/hdd4 /mnt/hdd4 etx3 to my /etc/fstab file.