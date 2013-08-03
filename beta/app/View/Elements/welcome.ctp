<div id="welcome">
  Welcome
    <span id="username"> <?php $this->Session->read('Auth.User.username') ?> </span>
  | World:
    <select id="worldselect" onChange="changeWorld()">
      <option>W19</option>
      <option>W30</option>
      <option>W38</option>
      <option>W42</option>
      <option>W46</option>
      <option>W48</option>
      <option>W56</option>
      <option>W58</option>
      <option>W59</option>
      <option>W60</option>
      <option>W61</option>
      <option>W63</option>
      <option>W64</option>
      <option>W65</option>
      <option>W66</option>
      <option>W67</option>
      <option>W68</option>
      <option>W69</option>
      <option>W70</option>
    </select>
    <br />
    <span id="lastupdatetext">Last updated <?php echo "xx" ?>h ago.</span>
</div>