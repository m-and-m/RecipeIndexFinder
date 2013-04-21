use index_finder;

delete from tag;

load data local infile '/Users/mo2xe/Desktop/indexFinder/csv_data/tag.csv' 
into table index_finder.tag
fields terminated by ',' 
enclosed by '"' 
escaped by '\\' 
lines terminated by '\r' 
ignore 1 lines;
