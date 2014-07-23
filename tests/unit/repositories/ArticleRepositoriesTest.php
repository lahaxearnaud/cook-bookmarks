<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 23/07/14
 * Time: 21:35
 */

/**
 * Class ArticleRepositoriesTest
 *
 */
class ArticleRepositoriesTest extends RepositoryCase{

    /**
     *
     * must match with the bind
     * ex:
     *      For :
     *          App::bind('NotesRepository', function ($app) {...});
     *      This function return 'NotesRepository'
     *
     * @return string
     */
    function getRepositoryName ()
    {
        return 'ArticlesRepository';
    }

    /**
     * ============================================
     *  FindAllBy
     * ============================================
     */
    function testHasOk ()
    {
        // TODO: Implement testHasOk() method.
    }

    function testHasKo ()
    {
        // TODO: Implement testHasKo() method.
    }


    /**
     * ============================================
     *  Update
     * ============================================
     */
    function testUpdateOk ()
    {
        // TODO: Implement testUpdateOk() method.
    }

    function testUpdateKo ()
    {
        // TODO: Implement testUpdateKo() method.
    }

    /**
     * ============================================
     *  Create
     * ============================================
     */
    function testCreateOk ()
    {
        // TODO: Implement testCreateOk() method.
    }

    function testCreateKo ()
    {
        // TODO: Implement testCreateKo() method.
    }

    /**
     * ============================================
     *  Search
     * ============================================
     */
    function testSearchOk ()
    {
        // TODO: Implement testSearchOk() method.
    }

    function testSearchKo ()
    {
        // TODO: Implement testSearchKo() method.
    }
}