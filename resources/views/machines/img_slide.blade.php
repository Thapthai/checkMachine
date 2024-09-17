<div class="container-fluid">
    <strong>
        <h2>รูปภาพเครื่องจักร</h2>

    </strong>
    <div class="wrapper" style="height: 55%">
        <ul class="carousel">
            @foreach ($data_machines as $data_machine)
                @if (!is_null($data_machine->pic1))
                    <li class="card">
                        <div class="image-container">
                            <img src="{{ url('storage/' . $data_machine->pic1) }}" alt="img" draggable="false">
                        </div>
                    </li>
                @else
                    <li class="card">
                        <h2>ไม่มีรูปภาพ</h2>
                    </li>
                @endif

                @if (!is_null($data_machine->pic2))
                    <li class="card">
                        <div class="image-container">
                            <img src="{{ url('storage/' . $data_machine->pic2) }}" alt="img" draggable="false">
                        </div>
                    </li>
                @else
                @endif

                @if (!is_null($data_machine->pic3))
                    <li class="card">

                        <div class="image-container">
                            <img src="{{ url('storage/' . $data_machine->pic3) }}" alt="img" draggable="false">
                        </div>
                    </li>
                @else
                @endif
                @if (!is_null($data_machine->pic4))
                    <li class="card">
                        <div class="image-container">
                            <img src="{{ url('storage/' . $data_machine->pic4) }}" alt="img" draggable="false">
                        </div>
                    </li>
                @else
                @endif
                @if (!is_null($data_machine->pic5))
                    <li class="card">
                        <div class="image-container">
                            <img src="{{ url('storage/' . $data_machine->pic5) }}" alt="img" draggable="false">
                        </div>
                    </li>
                @else
                @endif
                @if (!is_null($data_machine->pic6))
                    <li class="card">
                        <div class="image-container">
                            <img src="{{ url('storage/' . $data_machine->pic6) }}" alt="img" draggable="false">
                        </div>
                    </li>
                @else
                @endif
                @if (!is_null($data_machine->pic7))
                    <li class="card">
                        <div class="image-container">
                            <img src="{{ url('storage/' . $data_machine->pic7) }}" alt="img" draggable="false">
                        </div>
                    </li>
                @else
                @endif
                @if (!is_null($data_machine->pic8))
                    <li class="card">
                        <div class="image-container">
                            <img src="{{ url('storage/' . $data_machine->pic8) }}" alt="img" draggable="false">
                        </div>
                    </li>
                @else
                @endif
                @if (!is_null($data_machine->pic9))
                    <li class="card">
                        <div class="image-container">
                            <img src="{{ url('storage/' . $data_machine->pic9) }}" alt="img" draggable="false">
                        </div>
                    </li>
                @else
                @endif
                @if (!is_null($data_machine->pic10))
                    <li class="card">
                        <div class="image-container">
                            <img src="{{ url('storage/' . $data_machine->pic10) }}" alt="img" draggable="false">
                        </div>
                    </li>
                @else
                @endif
            @endforeach
        </ul>
        <i id="left" class="fa-solid fa-angle-left"></i>
        <i id="right" class="fa-solid fa-angle-right"></i>
    </div>
    <br>
</div>
