class AddContourMapToOutlets < ActiveRecord::Migration
  def change
    add_column :outlets, :contour_map, :string
  end
end
