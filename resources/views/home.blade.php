@extends('layouts.app')

@section('content')

    <section class="hero is-primary">
    <div class="hero-body">
        <div class="container">
        <h1 class="title">
            Primary title
        </h1>
        <h2 class="subtitle">
            Primary subtitle
        </h2>
        </div>
    </div>
    </section>
    <div class="container is-fluid">
        <div class="columns">
            <div class="column is-12">

                <div class="form-container">
                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control">
                            <input class="input" type="text" placeholder="Text input">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Username</label>
                        <div class="control has-icons-left has-icons-right">
                            <input class="input is-success" type="text" placeholder="Text input" value="bulma">
                            <span class="icon is-small is-left">
                            <i class="fas fa-user"></i>
                            </span>
                            <span class="icon is-small is-right">
                            <i class="fas fa-check"></i>
                            </span>
                        </div>
                        <p class="help is-success">This username is available</p>
                    </div>

                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control has-icons-left has-icons-right">
                            <input class="input is-danger" type="email" placeholder="Email input" value="hello@">
                            <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                            </span>
                            <span class="icon is-small is-right">
                            <i class="fas fa-exclamation-triangle"></i>
                            </span>
                        </div>
                        <p class="help is-danger">This email is invalid</p>
                    </div>

                    <div class="field">
                        <label class="label">Subject</label>
                        <div class="control">
                            <div class="select">
                            <select>
                                <option>Select dropdown</option>
                                <option>With options</option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Message</label>
                        <div class="control">
                            <textarea class="textarea" placeholder="Textarea"></textarea>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="checkbox">
                            <input type="checkbox">
                            I agree to the <a href="#">terms and conditions</a>
                            </label>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="radio">
                            <input type="radio" name="question">
                            Yes
                            </label>
                            <label class="radio">
                            <input type="radio" name="question">
                            No
                            </label>
                        </div>
                    </div>

                    <div class="field is-grouped">
                        <div class="control">
                            <button class="button is-link">Submit</button>
                        </div>
                        <div class="control">
                            <button class="button is-text">Cancel</button>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    <table class="table table is-striped is-fullwidth">
                        <thead>
                            <tr>
                            <th><abbr title="Position">Pos</abbr></th>
                            <th>Team</th>
                            <th><abbr title="Played">Pld</abbr></th>
                            <th><abbr title="Won">W</abbr></th>
                            <th><abbr title="Drawn">D</abbr></th>
                            <th><abbr title="Lost">L</abbr></th>
                            <th><abbr title="Goals for">GF</abbr></th>
                            <th><abbr title="Goals against">GA</abbr></th>
                            <th><abbr title="Goal difference">GD</abbr></th>
                            <th><abbr title="Points">Pts</abbr></th>
                            <th>Qualification or relegation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>1</th>
                                <td><a href="https://en.wikipedia.org/wiki/Leicester_City_F.C." title="Leicester City F.C.">Leicester City</a> <strong>(C)</strong>
                                </td>
                                <td>38</td>
                                <td>23</td>
                                <td>12</td>
                                <td>3</td>
                                <td>68</td>
                                <td>36</td>
                                <td>+32</td>
                                <td>81</td>
                                <td>Qualification for the <a href="https://en.wikipedia.org/wiki/2016%E2%80%9317_UEFA_Champions_League#Group_stage" title="2016–17 UEFA Champions League">Champions League group stage</a></td>
                            </tr>
                            <tr>
                                <th>2</th>
                                <td><a href="https://en.wikipedia.org/wiki/Arsenal_F.C." title="Arsenal F.C.">Arsenal</a></td>
                                <td>38</td>
                                <td>20</td>
                                <td>11</td>
                                <td>7</td>
                                <td>65</td>
                                <td>36</td>
                                <td>+29</td>
                                <td>71</td>
                                <td>Qualification for the <a href="https://en.wikipedia.org/wiki/2016%E2%80%9317_UEFA_Champions_League#Group_stage" title="2016–17 UEFA Champions League">Champions League group stage</a></td>
                            </tr>
                            <tr>
                                <th>3</th>
                                <td><a href="https://en.wikipedia.org/wiki/Tottenham_Hotspur_F.C." title="Tottenham Hotspur F.C.">Tottenham Hotspur</a></td>
                                <td>38</td>
                                <td>19</td>
                                <td>13</td>
                                <td>6</td>
                                <td>69</td>
                                <td>35</td>
                                <td>+34</td>
                                <td>70</td>
                                <td>Qualification for the <a href="https://en.wikipedia.org/wiki/2016%E2%80%9317_UEFA_Champions_League#Group_stage" title="2016–17 UEFA Champions League">Champions League group stage</a></td>
                            </tr>
                            <tr class="is-selected">
                                <th>4</th>
                                <td><a href="https://en.wikipedia.org/wiki/Manchester_City_F.C." title="Manchester City F.C.">Manchester City</a></td>
                                <td>38</td>
                                <td>19</td>
                                <td>9</td>
                                <td>10</td>
                                <td>71</td>
                                <td>41</td>
                                <td>+30</td>
                                <td>66</td>
                                <td>Qualification for the <a href="https://en.wikipedia.org/wiki/2016%E2%80%9317_UEFA_Champions_League#Play-off_round" title="2016–17 UEFA Champions League">Champions League play-off round</a></td>
                            </tr>
                            <tr>
                                <th>5</th>
                                <td><a href="https://en.wikipedia.org/wiki/Manchester_United_F.C." title="Manchester United F.C.">Manchester United</a></td>
                                <td>38</td>
                                <td>19</td>
                                <td>9</td>
                                <td>10</td>
                                <td>49</td>
                                <td>35</td>
                                <td>+14</td>
                                <td>66</td>
                                <td>Qualification for the <a href="https://en.wikipedia.org/wiki/2016%E2%80%9317_UEFA_Europa_League#Group_stage" title="2016–17 UEFA Europa League">Europa League group stage</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
