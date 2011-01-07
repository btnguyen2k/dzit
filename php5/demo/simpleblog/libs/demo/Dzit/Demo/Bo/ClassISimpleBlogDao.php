<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
interface Dzit_Demo_Bo_ISimpleBlogDao {
    /**
     * Gets latest $num posts.
     *
     * @param int $num limit the number of posts to retrieve
     * @return Array an array of Dzit_Demo_Bo_Post
     */
    public function getLatestPosts($num);

    /**
     * Creates a post.
     *
     * @param Dzit_Demo_Bo_Post $post
     * @return Dzit_Demo_Bo_Post the created post
     */
    public function createPost($post);

    /**
     * Deletes a post by id.
     *
     * @param int $postId
     */
    public function deletePost($postId);
}
