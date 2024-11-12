
################## PROMPT ##################
I created a widget for elementor and I'm having some trouble achieving my goals with it.
I need the title to sit exactly at the bottom of the div and to be centered horizontally when the div isn't hovered.
When I hover the div I need the title to go up so it will sit exactly on top of the paragraph so it will look as if it was pushed up by the paragraph.
I think I need to calculate the height of the paragraph and use it to determine where to put the title.
But I can't seem to get it to work.
Can you help me with that?














################## PROMPT ##################
I am developing a widget for elementor and I need you to help me do it.
I already have a plugin file so dont make me a new one just tell me the line of code to include my widget inside of it.

Information for the widget:
The widget's file name is "categories-grid-widget.php" and it sits inside the plugin folder in a "widgets" folder.
The widget's CSS file name is "categories-grid-sidget-style.css".
I attached my plugin main file so you can implement the widget inside of it.

The widget is supposed to be a repeater widget that let's the user add items.
Each item should have a div with a title, a paragraph, and a background image for the div

Behavior:
1. Each div should take a third of the width of the parent(the container I will put the widget in inside elementor) and should have some spacing.
The goal is to have 3 divs in 1 line. On mobile there will be only 1 div per line which means he'll take 100% of the width.
The div will have a border-radius of 10px.
2. The paragraph should not be visible unless you hover the main div and only then it will be visible with a smooth fade in transition.
3. The title is always visible and is relying on the paragraph. When the div is not hovered, the title will be aligned to the bottom center of the div with some spacing.
When the div is being hovered, a script will be trigerred to calculate the height of the paragraph and then it will change the location of the title along the Y axis to sit exactly on top
of the paragraph with some spacing.

Controls:
I need to be able to control the title with the native elementor font editor(size, weight, box shadow, line height etc...)
I need to be able to control the paragraph with a regular wysiwyg as in native elementor text editor
I need to be able to control the background color and its properties(location, if he fits, covers etc, repeatability etc...)

Please walk me through step by step on how to achieve that and give me a short, concise and organized code.

