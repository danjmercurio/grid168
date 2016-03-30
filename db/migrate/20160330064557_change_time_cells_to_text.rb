class ChangeTimeCellsToText < ActiveRecord::Migration
  def change
    change_column :offers, :time_cells, :text
  end
end
