use index_finder;

delete from tag;

load data local infile '/Applications/MAMP/htdocs/RIF/csv_data/tag.csv' 
into table index_finder.tag
fields terminated by ',' 
enclosed by '"' 
escaped by '\\' 
lines terminated by '\r' 
ignore 1 lines;
