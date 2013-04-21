use index_finder;

delete from recipe;

load data local infile '/Users/mo2xe/Desktop/indexFinder/csv_data/recipe.csv' 
into table index_finder.recipe
fields terminated by ',' 
enclosed by '"' 
escaped by '\\' 
lines terminated by '\r' 
ignore 1 lines;
