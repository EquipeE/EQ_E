#!/bin/sh
chown apache:apache ../ ../html/ ../img/posts/ ../txt # Dando permissão de escrita nas pastas corretas.

../php/posts/add_post.php "Stallman's Momentary Lapse of Reason" art1.png ../txt/interjection.txt
../php/posts/add_post.php "História chocante acontece na USP" art2.png ../txt/usp.txt
../php/posts/add_post.php "O Monólogo" art3.png ../txt/truth.txt
../php/posts/add_post.php "Post 4" art4.png ../txt/ratinho.txt
../php/posts/add_post.php "Just as the founding fathers intended." art1.png ../txt/founding_fathers.txt
