<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 23/07/14
 * Time: 21:35
 */

/**
 * Class NoteRepositoriesTest
 *
 */
class NoteRepositoriesTest extends RepositoryCase
{
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
    public function getRepositoryName()
    {
        return 'NotesRepository';
    }

    /**
     * ============================================
     *  FindAllBy
     * ============================================
     */
    public function testHasOk()
    {
        // TODO: Implement testHasOk() method.
    }

    public function testHasKo()
    {
        // TODO: Implement testHasKo() method.
    }

    /**
     * ============================================
     *  Update
     * ============================================
     */
    public function testUpdateOk()
    {
        // TODO: Implement testUpdateOk() method.
    }

    public function testUpdateKo()
    {
        // TODO: Implement testUpdateKo() method.
    }

    /**
     * ============================================
     *  Create
     * ============================================
     */
    public function testCreateOk()
    {
        // TODO: Implement testCreateOk() method.
    }

    public function testCreateKo()
    {
        // TODO: Implement testCreateKo() method.
    }

    /**
     * ============================================
     *  Search
     * ============================================
     */
    public function testSearchOk()
    {
        // TODO: Implement testSearchOk() method.
    }

    public function testSearchKo()
    {
        // TODO: Implement testSearchKo() method.
    }
}
