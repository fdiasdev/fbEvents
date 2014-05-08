<div>

    <h1>Facebook Events List</h1>

    <p>Visualize abaixo seus eventos do Facebook:</p>

    <div class="row">

        {% for event in events %}
            <div class="medium-6 columns panel">
                <h3>Name: {{ event['name']|e }}</h3>
                <br />
                <h4>Date: {{ event['start_time'] }}</h4>
                <br />
                <p>
                {% if event['rsvp_status'] == "attending" %}
                    <span class="label">
                {% else %}
                    <span class="label alert">
                {% endif  %}
                    Status: {{ event['rsvp_status'] }}
                </span></p>
            </div>
        {% else %}
            <h2>Não há eventos para exibir</h2>
        {% endfor  %}

    </div>

</div>