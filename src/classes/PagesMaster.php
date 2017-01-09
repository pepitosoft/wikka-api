<?php
class PagesMapper extends Mapper
{
  public function getDef() {
      if( $this->db->getAttribute(PDO::ATTR_DRIVER_NAME) == "sqlite" ){
        $sql = "PRAGMA table_info([".$this->settings['db']['prefix']."pages])";
      } else {
        $sql = "DESCRIBE ".$this->settings['db']['prefix']."pages";
      }
      $stmt = $this->db->query($sql);
      $results = [];
      while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
          $results[] = $row;
      }
      return $results;
  }

  public function getPages() {
      $sql = "SELECT p.id, p.tag, p.title, p.time, p.body, p.owner, p.user, p.latest, p.note
          from wikka_pages p";
      $stmt = $this->db->query($sql);
      //$pages = $result->fetch(PDO::FETCH_OBJ);
      $results = [];
      while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
          $row->body = base64_encode($row->body);
          $results[] = $row;
      }
      return $results;
  }

    public function getPages123() {
        $sql = "SELECT p.id, p.tag, p.title, u.email
            from wikka_pages p
            join wikka_users u on (u.name = p.owner)";
        $stmt = $this->db->query($sql);
        $results = [];
        while($row = $stmt->fetch()) {
            $results[] = new TicketEntity($row);
        }
        return $results;
    }
    /**
     * Get one ticket by its ID
     *
     * @param int $ticket_id The ID of the ticket
     * @return TicketEntity  The ticket
     */
    public function getTicketById($ticket_id) {
        $sql = "SELECT t.id, t.title, t.description, c.component
            from tickets t
            join components c on (c.id = t.component_id)
            where t.id = :ticket_id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["ticket_id" => $ticket_id]);
        if($result) {
            return new TicketEntity($stmt->fetch());
        }
    }
    public function save(TicketEntity $ticket) {
        $sql = "insert into tickets
            (title, description, component_id) values
            (:title, :description,
            (select id from components where component = :component))";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "title" => $ticket->getTitle(),
            "description" => $ticket->getDescription(),
            "component" => $ticket->getComponent(),
        ]);
        if(!$result) {
            throw new Exception("could not save record");
        }
    }
}
