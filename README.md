# WessBlog Project

This project is a comprehensive blog platform that offers various features for user interaction and content management.

## User Features
- **Authentication:** Secure login, signup, and password reset via email.
- **Profile Management:** Personalize settings, add, remove, and edit posts.
- **Social Interaction:** Follow other users and view the list of followed users on your profile.

## Home Page
- **Top Post:** The top post is prominently displayed in a large section.
- **Search Functionality:** Easily search for posts.
- **Trending Posts:** Highlight posts with the most claps.
- **Explore Topics:** Discover various topics.
- **Latest Posts:** Stay updated with the newest posts.

## Topic Pages
- View posts specific to a selected topic.

## Post Page
- **Clap Feature:** Engage with posts by clapping for them.
- **Comments:**
  - Author: 
    - Cannot create a comment on their own post.
    - Can reply to any comment on their own post.
  - User:
    - Can comment on any post.
    - Cannot reply to comments made by other users; they can only reply to their own comments.
    - Cannot delete their main comment if it has at least one reply.
  - Clapping:
    - Users can clap for any comment.
    - The comment with the most claps is highlighted as the "Top Comment.".
  - This structure adds depth to user interaction, allowing engagement through comments and a voting system while maintaining boundaries for authors and users regarding comment management.

## Architecture
This project uses the **MVC (Model-View-Controller)** architecture for structured and organized code management.

Explore, interact, and share your thoughts with the community!
