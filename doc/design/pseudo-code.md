# Pseudo Code

This is a sample pseudo code for adding a todo item as requested by the user.

if the title is not provided:
    throw an error
set the title on the item
if a longer description is provided:
    set the description
if a deadline is provided:
    set the deadline date
if a project is provided:
    set the project id
if a responsible is provided:
    set the person id
if this is a subitem:
    set the parent item id
if at least one tag is provided:
    for each tag:
        add the tag to the item
store the item in the database
