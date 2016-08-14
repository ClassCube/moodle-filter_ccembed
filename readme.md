# ClassCube Moodle Filter

Filter plugin for Moodle that allows you to embed problems directly from 
[ClassCube](https://classcube.com) into any type of Moodle content page. 

## About

Using [ClassCube](https://classcube.com) and Moodle together, you're able to create external 
assignments where your students can complete code assignments online
and have their grades sent back to Moodle. You can even go and look 
at their code and watch their process as they worked through their
solution.

But sometimes you may not need it to be graded. Sometimes you may just
want to put a problem online inside some type of reference.

With this plugin you'll be able to embed a ClassCube problem into a
Moodle page, book, lesson, forum post, or any content page. You could
even put it on the course overview page as part of a label. Basically
anywhere that Moodle will apply a filter can have a problem embedded.

The main difference between this plugin and using ClassCube as an external
tool is grades. Since there's no assignment connected to the embedded
problem through this plugin, there's no grade. If you need a grade, use
the external tool activity. If you want to demo, use this.

That said, you'll still have access to all of your students' submissions
so you can see what they did. If you choose to assign a grade for that, you
can. It's just not automatic. 

## Installation

Rather than copy and paste here, take a look at the Moodle Documentation
on [how to install a plugin](https://docs.moodle.org/31/en/Installing_plugins) .
What you're looking for is how to install a plugin from a zip file.  

## Setup

### Moodle Setup

After uploading the plugin, you'll typically have to tell Moodle that you
want the filter active. 

To activate, go to Site Administration -> Plugins -> Filters -> Manage Filters.
You should see a screen similar to the following. 

![](https://classcube.com/wp-content/uploads/2016/08/manage-filters.png) 

The ClassCube Embed filter will probably not be towards the top, and probably
won't be active. You can set it to either On or Off, But Available. If it's On, 
the filter will be active on all pages site wide. If it's Off, But Available 
teachers will be able to use it in their courses but must enable it individually.

### Filter Settings

Also under Site Administration -> Plugins -> Filters you should find a ClassCube
Embed link that will take you to the settings for this plugin.

![](https://classcube.com/wp-content/uploads/2016/08/filter-settings.png)

|Setting|Notes|
|---|---|
|Allow Full Screen|If enabled, the filter will add an `allowfullscreen` attribute to the iframes that are created. In most browsers this will allow you and your students to toggle the problem to use the entire window instead of just the frame. Not all browsers support this though.|
|Hide Link Button|Normally, the problem menu has a link back to ClassCube. If you'd prefer that it not, check this box.|
|iframe CSS classes|If you have custom CSS in your theme and would like to target the iframe created by this plugin, you can add CSS classes here. The default `classcube-frame` does not have any styling associated with it. In fact, the plugin doesn't load any CSS.|
|iframe CSS styles|The easier way to style, especially if you can't edit your theme CSS, is to customize the CSS styles that are applied to the frame. By default it's set to fill the entire width and be 300 pixels tall.|
|User Information|Moodle has to send ClassCube enough information to uniquely identify the user. It can optionally send the user's name and email address, and we suggest that you let it do so. Otherwise ClassCube will create a user with a random name and email address which makes it very difficult for your teachers to correlate submissions with their students.|
|Client Key/Secret|These are the keys that Moodle and ClassCube use to communicate securely and are created in your account on ClassCube. If you're already using ClassCube as an external tool, you can probably leave both fields empty. The plugin will look in course and global settings for a key if these fields are blank.|


## Using the plugin

Now comes the easy part... all you have to do is paste the link to a ClassCube problem 
into any Moodle content page. 

It's optional to create an assignment in ClassCube, although it's typically better to do so. 
Once you've got an assignment, copy the link. It's over on the right side where you
view the information on the assignment.

![](https://classcube.com/wp-content/uploads/2016/08/copy-link.png)

Now go to where ever you want to embed the problem. In this case I'm going to use 
a forum post, but it should work where ever you have the filter active.

![](https://classcube.com/wp-content/uploads/2016/08/forum-post.png)

Save the post, and there you go. A ClassCube problem embedded into a forum post.

![](https://classcube.com/wp-content/uploads/2016/08/embedded-problem.png)

## Troubleshooting

If you only see the link that you pasted in, it's most likely because the filter
isn't active on that particular page. 

If you do see the frame, but you see some type of message, there should be
an explanation of the problem. Most common cause here would be an invalid
key. 

## Support

If you're looking for help specifically on this plugin, please visit our
[Moodle Plugin Support Forums](https://classcube.com/forum/moodle-plugins/)

If you come across a bug or would like to take a look at the code, this plugin
is also available on [GitHub](https://github.com/ClassCube/moodle-filter_ccembed)

Our main site is [ClassCube.com](https://classcube.com)
