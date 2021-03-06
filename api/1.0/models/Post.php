<?php
class Post {
    /**
     * @var string
     */
    private $table = 'posts';

    /**
     * @var object 
     */
    private $conn;

    /**
     * @var integer
     */
    public $post_id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $body;

    /**
     * @var string
     */
    public $author;

    /**
     * @var integer
     */
    public $category_id;

    /**
     * @var string
     */
    public $category_name;

    /**
     * @var string
     */
    public $created_at;

    /**
     * Post constructor
     * @param object $database
     */
    public function __construct($database)
    {
        $this->conn = $database;
    }

    /**
     * Get Posts
     * 
     * @return object
     */
    public function read()
    {       
        // Prepare statement
        $stmt = $this->conn->prepare(
            "SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM " .
                $this->table . " p
                LEFT JOIN categories c ON p.category_id = c.id
            ORDER BY
                p.created_at DESC"
        );

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get single post
    public function readSingle()
    {
        // Prepare statement
        $stmt = $this->conn->prepare(
            "SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM " .
                $this->table . " p
                LEFT JOIN categories c ON p.category_id = c.id
            WHERE
                p.id = :id"
        );

        // Execute query
        $stmt->execute(array(
            ':id' => $this->post_id
        ));

        return $stmt;
    }

    // Create post
    public function create()
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO " . $this->table . "
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id"
        );

        if ($stmt->execute(array(
            ':title' => htmlspecialchars(strip_tags($this->title)),
            ':body' => htmlspecialchars(strip_tags($this->body)),
            ':author' => htmlspecialchars(strip_tags($this->author)),
            ':category_id' => htmlspecialchars(strip_tags($this->category_id))
        ))) {
            return true;
        }

        // Print error
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Update post
    public function update()
    {
        $stmt = $this->conn->prepare(
            "UPDATE " . $this->table . "
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
            WHERE
                id = :id"
        );

        if ($stmt->execute(array(
            ':title' => htmlspecialchars(strip_tags($this->title)),
            ':body' => htmlspecialchars(strip_tags($this->body)),
            ':author' => htmlspecialchars(strip_tags($this->author)),
            ':category_id' => htmlspecialchars(strip_tags($this->category_id)),
            ':id' => htmlspecialchars(strip_tags($this->post_id))
        ))) {
            return true;
        }

        // Print error
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete post
    public function delete()
    {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE id = :id");
        
        if ($stmt->execute(array(
            ":id" => $this->post_id
        ))) {
            return true;
        }

        // Print error
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}