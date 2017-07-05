# Optional variables for a backup script
MYSQL_USER="root"
MYSQL_PASS="toor"
BACKUP_DIR=mysql_bkup/$(date +%Y-%m-%dT%H_%M_%S);
test -d "$BACKUP_DIR" || mkdir -p "$BACKUP_DIR"
# Get the database list, exclude information_schema
for db in $(mysql -B -s -u $MYSQL_USER --password=$MYSQL_PASS -e 'show databases' | grep -v information_schema)
do
  # dump each database in a separate file
  mysqldump -u $MYSQL_USER --password=$MYSQL_PASS "$db" | gzip > "$BACKUP_DIR/$db.sql.gz"
done
