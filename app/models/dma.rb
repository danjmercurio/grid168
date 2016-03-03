# == Schema Information
#
# Table name: dmas
#
#  id         :integer(4)      not null, primary key
#  name       :string(255)
#  city_id    :integer(4)
#  created_at :datetime
#  updated_at :datetime
#

class Dma < ActiveRecord::Base
  belongs_to :city
  has_one :outlet
end
