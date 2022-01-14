## WP-Admin

This programm works only with Linux based OS and PHP

### Installation
```
composer install
```

### Configuration
Update paths in 
```
./config/app.ini
```


### Single Backup for Wordpress
```
./wp-admin backup [path_to_wordpress]

```
### Single Backup and FTP transfer for Wordpress
```
./wp-admin backup [path_to_wordpress] -t

```
### Single Update and FTP transfer for Wordpress
```
./wp-admin update [path_to_wordpress]
```

### Batch Backup with CSV file
```
./wp-admin backupsource
```
### Batch update with CSV file
```
./wp-admin updatesource
```



