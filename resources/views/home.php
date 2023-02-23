<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form data</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <div class="row">
        <h1 class="mt-3 mb-5">Simple example of form processing</h1>

        <div class="card">
            <div class="card-body">
                <div class="card-title">Simple form</div>

                <form action="/save-form" method="post" onsubmit="App.send_form(event)">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Height</th>
                            <th scope="col">Length</th>
                            <th scope="col">Depth</th>
                            <th scope="col">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($vars['form_data'] as $datum) { ?>
                                <tr>
                                    <td>
                                        <input type="hidden"
                                               name="form_data[<?= $datum->id() ?>][form_data_id]"
                                               value="<?= $datum->id() ?>"
                                        >
                                        <?= $datum->id() ?>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="number"
                                                   class="form-control"
                                                   placeholder="Height"
                                                   aria-label="Height"
                                                   aria-describedby="height<?= $datum->id() ?>"
                                                   min="0"
                                                   required
                                                   autocomplete="off"
                                                   name="form_data[<?= $datum->id() ?>][height]"
                                                   value="<?= $datum->height ?>"
                                                   readonly
                                            >
                                            <span class="input-group-text" id="height<?= $datum->id() ?>">cm</span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="input-group">
                                            <input type="number"
                                                   class="form-control"
                                                   placeholder="Length"
                                                   aria-label="Length"
                                                   aria-describedby="length<?= $datum->id() ?>"
                                                   min="0"
                                                   required
                                                   autocomplete="off"
                                                   name="form_data[<?= $datum->id() ?>][length]"
                                                   value="<?= $datum->length ?>"
                                                   readonly
                                            >
                                            <span class="input-group-text" id="length<?= $datum->id() ?>">cm</span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="input-group">
                                            <input type="number"
                                                   class="form-control"
                                                   placeholder="Depth"
                                                   aria-label="Depth"
                                                   aria-describedby="depth<?= $datum->id() ?>"
                                                   min="0"
                                                   required
                                                   autocomplete="off"
                                                   name="form_data[<?= $datum->id() ?>][depth]"
                                                   value="<?= $datum->depth ?>"
                                                   readonly
                                            >
                                            <span class="input-group-text" id="depth<?= $datum->id() ?>">cm</span>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                            <?php } ?>

                            <?php $last_key = count($vars['form_data']) + 1; ?>
                            <tr>
                                <td><?= $last_key ?></td>
                                <td>
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               placeholder="Height"
                                               aria-label="Height"
                                               aria-describedby="height<?= $last_key ?>"
                                               min="0"
                                               required
                                               autocomplete="off"
                                               name="form_data[<?= $last_key ?>][height]"
                                               value=""
                                        >
                                        <span class="input-group-text" id="height<?= $last_key ?>">cm</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               placeholder="Length"
                                               aria-label="Length"
                                               aria-describedby="length<?= $last_key ?>"
                                               min="0"
                                               required
                                               autocomplete="off"
                                               name="form_data[<?= $last_key ?>][length]"
                                               value=""
                                        >
                                        <span class="input-group-text" id="length<?= $last_key ?>">cm</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number"
                                               class="form-control"
                                               placeholder="Depth"
                                               aria-label="Depth"
                                               aria-describedby="depth<?= $last_key ?>"
                                               min="0"
                                               required
                                               autocomplete="off"
                                               name="form_data[<?= $last_key ?>][depth]"
                                               value=""
                                        >
                                        <span class="input-group-text" id="depth<?= $last_key ?>">cm</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        <span role="button"
                                                class="btn btn-outline-danger"
                                                onclick="this.closest('tr').remove()"
                                        >
                                            Delete
                                        </span>
                                        <span role="button"
                                                class="btn btn-outline-primary"
                                                onclick="App.clone_row(event)"
                                        >
                                            Add
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-primary">Submit form</button>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

<script>
    const App = {
        clone_row: function (event) {
            let $tr = $(event.target.closest('tr').parentNode.lastElementChild);
            let $clone = $tr.clone();

            let inputs = $clone.find('input');

            $clone.find('td:first-child').html(Number($clone.find('td:first-child').html()) + 1);

            inputs.attr('aria-describedby', function() {
                let parts = this.getAttribute('aria-describedby').match(/(\D+)(\d+)$/);
                let describedby = parts[1] + ++parts[2];

                this.nextElementSibling.setAttribute('id', describedby);

                return describedby;
            });

            inputs.attr('name', function() {
                let parts = this.getAttribute('name').match(/.*(\d).*/);
                return parts[0].replace(parts[1], ++parts[1]);
            });

            $clone.find('input[type="number"]').val('');
            $tr.closest('tbody').append($clone);
        },
        send_form: function (event) {
            event.preventDefault();

            let form_data = {};
            let pointer = form_data;

            /**
             * Build pretty JSON object
             */
            [].forEach.call(event.target.querySelectorAll('input[name]'), input => {
                let parts = input.getAttribute('name').split(/\[|\]\[/);

                for (let i in parts) {
                    if (parts[i].charAt(parts[i].length - 1) === ']') {
                        parts[i] = parts[i].substring(0, parts[i].length - 1);
                    }

                    if (i < parts.length - 1) {
                        pointer[parts[i]] = pointer[parts[i]] === undefined
                                                ? {} : pointer[parts[i]];
                        pointer = pointer[parts[i]];
                    } else {
                        pointer[parts[i]] = input.value;
                        pointer = form_data;
                    }
                }
            });

            $.ajax(event.target.action, {
                method: event.target.method,
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Basic ' + btoa('username:pass'),
                },

                data: JSON.stringify(form_data),
            }).then(response => {
                if (response.result !== undefined && response.result !== null) {
                    alert('New rows were inserted!!! Row ids: ' + response.created_data_ids);
                    window.location.reload();
                }
            }).catch(response => {
                console.error(response);
            });
        },
    };
</script>

</body>
</html>