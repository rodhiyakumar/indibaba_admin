<style>
    .bs-example-modal-lg .card-header {
        padding: 10px 10px;
        font-weight: 600;
    }

    .bs-example-modal-lg .card-body {
        padding: 10px;
    }

    .modal-content {
        border-radius: 10px;
    }

    .modal-dialog {
        max-width: 1000px;
    }
</style>
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">
                    @if (!$sectionId || $sectionId == 'null')
                        {{ $rankData[0]['examName'] }}
                    @else
                        {{ $rankData[0]['sectionName'] }} ({{ $rankData[0]['sectionRank'][0]['examName'] }})
                    @endif
                </h5>
                <button type="button" class="close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <h5 class="mt-4 text-primary">Rank</h5>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>
                                            #(Rank)
                                        </th>
                                        <th>
                                            User
                                        </th>
                                        <th>
                                            Marks
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!$sectionId || $sectionId == 'null')
                                        @foreach ($rankData as $rank)
                                            <tr>
                                                <td>{{ $rank['rank'] }}</td>
                                                <td>{{ $rank['name'] }}</td>
                                                <td>{{ $rank['totalMarks'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @foreach ($rankData[0]['sectionRank'] as $rank)
                                            <tr>
                                                <td>{{ $rank['rank'] }}</td>
                                                <td>{{ $rank['name'] }}</td>
                                                <td>{{ $rank['totalMarks'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function closeModal() {
        jQuery('#myModal').modal('hide');
        setTimeout(function() {
            jQuery('#myModal').remove();
            jQuery('modal-backdrop').remove();
        }, 500);
    }
</script>
