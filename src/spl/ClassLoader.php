<?php
interface ClassLoader{

    /**
     * @param ClassLoader $parent
     */
    public function __construct(ClassLoader $parent = \null);

    /**
     * Adds a path to the lookup list
     *
     * @param string $path
     * @param bool   $prepend
     */
    public function addPath($path, $prepend = \false);

    /**
     * Removes a path from the lookup list
     *
     * @param $path
     */
    public function removePath($path);

    /**
     * Returns an array of the classes loaded
     *
     * @return string[]
     */
    public function getClasses();

    /**
     * Returns the parent ClassLoader, if any
     *
     * @return ClassLoader
     */
    public function getParent();

    /**
     * Attaches the ClassLoader to the PHP runtime
     *
     * @param bool $prepend
     *
     * @return bool
     */
    public function register($prepend = \false);

    /**
     * Called when there is a class to load
     *
     * @param string $name
     *
     * @return bool
     *
     * @throws ClassNotFoundException
     */
    public function loadClass($name);

    /**
     * Returns the path for the class, if any
     *
     * @param string $name
     *
     * @return string|null
     */
    public function findClass($name);
}