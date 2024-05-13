FROM mysql:latest
COPY donneesValeursListes.SQL /docker-entrypoint-initdb.d/10-init.sql
COPY trigger_status.SQL /docker-entrypoint-initdb.d/20-init.sql