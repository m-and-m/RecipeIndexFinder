use index_finder;

delete from recipeTag;

load data local infile '/Applications/MAMP/htdocs/RIF/csv_data/recipeTag.csv' 
into table index_finder.recipeTag
fields terminated by ',' 
enclosed by '"' 
escaped by '\\' 
lines terminated by '\r' 
ignore 1 lines;
