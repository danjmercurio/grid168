class AddTimeCellsToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :time_cells, :string, :length => 255
  end
end
