use index_finder;

delete from recipeTag;

load data local infile '/Users/mo2xe/Desktop/indexFinder/csv_data/recipeTag.csv' 
into table index_finder.recipeTag
fields terminated by ',' 
enclosed by '"' 
escaped by '\\' 
lines terminated by '\r' 
ignore 1 lines;
