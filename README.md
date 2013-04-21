RecipeIndexFinder
=================
table schema
recipe
recipeid INT NOT NULL
name VARCHAR(50) NOT NULL
resource VARCHAR(50)
resourcelink VARCHAR(200)
PRIMARY KEY(recipeid)

tag
tagid VARCHAR(10) NOT NULL
name VARCHAR(30)
PRIMARY KEY(tagid)

recipeTag
recipeid INT NOT NULL
tagid VARCHAR(10) NOT NULL

contents
contentid varchar(30) not null,
ingredients text,
instructions text,
PRIMARY KEY(contentid)